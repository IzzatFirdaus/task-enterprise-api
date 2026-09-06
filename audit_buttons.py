import os, re
bad = ['click here','submit','more','learn more','read more','buy now']
for root, dirs, files in os.walk('resources/views'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                for b in bad:
                    if b in content.lower():
                        # only flag actual button/text occurrences, not just code
                        if '<button' in content or '<a' in content:
                            pass  # too noisy; skip
