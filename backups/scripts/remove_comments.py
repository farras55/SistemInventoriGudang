#!/usr/bin/env python3
import sys
import os
import shutil
from pathlib import Path

TEXT_EXT = {
    '.php', '.phtml', '.html', '.htm', '.css', '.js', '.json', '.sql', '.md', '.txt',
    '.xml', '.py', '.sh', '.java', '.c', '.cpp', '.h', '.hpp', '.svg', '.ini'
}

SKIP_DIRS = {'.git', 'node_modules', '__pycache__', 'vendor', 'backups'}

changed = []
backups = []

def should_process(path: Path):
    if path.is_dir():
        return False
    if path.suffix.lower() in TEXT_EXT:
        return True
    # also process files without suffix that look like text
    try:
        with open(path, 'rb') as f:
            sample = f.read(2048)
            if b'\0' in sample:
                return False
    except Exception:
        return False
    return True


def strip_comments(code: str, filename: str) -> str:
    # Generic stateful stripper handling: //, /* */, #, --, <!-- --> while
    # preserving strings (single/double/backtick) and escapes.
    out = []
    i = 0
    n = len(code)
    in_squote = in_dquote = in_bquote = False
    in_block = False
    in_line = False
    in_html = False
    while i < n:
        ch = code[i]
        nch = code[i+1] if i+1 < n else ''
        # handle end of block comment
        if in_block:
            if ch == '*' and nch == '/':
                in_block = False
                i += 2
                continue
            else:
                i += 1
                continue
        if in_html:
            if ch == '-' and code[i:i+3] == '-->':
                in_html = False
                i += 3
                continue
            else:
                i += 1
                continue
        if in_line:
            if ch == '\n':
                in_line = False
                out.append(ch)
                i += 1
                continue
            else:
                i += 1
                continue
        # if in string, copy until string ends (respect escapes)
        if in_squote:
            out.append(ch)
            if ch == "'":
                in_squote = False
            elif ch == '\\':
                if i+1 < n:
                    out.append(code[i+1])
                    i += 1
            i += 1
            continue
        if in_dquote:
            out.append(ch)
            if ch == '"':
                in_dquote = False
            elif ch == '\\':
                if i+1 < n:
                    out.append(code[i+1])
                    i += 1
            i += 1
            continue
        if in_bquote:
            out.append(ch)
            if ch == '`':
                in_bquote = False
            elif ch == '\\':
                if i+1 < n:
                    out.append(code[i+1])
                    i += 1
            i += 1
            continue
        # detect comment starts
        # HTML comment
        if ch == '<' and code[i:i+4] == '<!--':
            in_html = True
            i += 4
            continue
        # C-style block
        if ch == '/' and nch == '*':
            in_block = True
            i += 2
            continue
        # C++ style line
        if ch == '/' and nch == '/':
            in_line = True
            i += 2
            continue
        # SQL style line comment --
        if ch == '-' and nch == '-' and (i+2==n or code[i+2].isspace() or code[i+2] in ('\t','\r','\n')):
            in_line = True
            i += 2
            continue
        # hash-style comment (shell, python, ini)
        if ch == '#':
            in_line = True
            i += 1
            continue
        # start of strings
        if ch == "'":
            in_squote = True
            out.append(ch)
            i += 1
            continue
        if ch == '"':
            in_dquote = True
            out.append(ch)
            i += 1
            continue
        if ch == '`':
            in_bquote = True
            out.append(ch)
            i += 1
            continue
        # default copy
        out.append(ch)
        i += 1
    return ''.join(out)


def process_file(path: Path, root: Path):
    try:
        text = path.read_text(encoding='utf-8')
    except UnicodeDecodeError:
        try:
            text = path.read_text(encoding='latin-1')
        except Exception:
            return False
    stripped = strip_comments(text, str(path))
    if stripped != text:
        # backup
        rel = path.relative_to(root)
        bkdir = root / 'backups'
        dest = bkdir / rel
        dest.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(path, dest)
        path.write_text(stripped, encoding='utf-8')
        changed.append(str(rel))
        backups.append(str(dest.relative_to(root)))
        return True
    return False


def main():
    if len(sys.argv) > 1:
        root = Path(sys.argv[1])
    else:
        root = Path('.').resolve()
    root = root.resolve()
    print('Root:', root)
    for p in root.rglob('*'):
        if any(part in SKIP_DIRS for part in p.parts):
            continue
        if should_process(p):
            process_file(p, root)
    print('\nDone. Files changed:', len(changed))
    for f,b in zip(changed, backups):
        print('- ', f, ' (backup: ', b, ')')

if __name__ == '__main__':
    main()
