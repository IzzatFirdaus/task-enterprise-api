import os
found = False
for root, dirs, files in os.walk('resources/views'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                if 'loading="lazy"' in content:
                    print(p + ' has lazy')
                    found = True
if not found:
    print('No lazy loading attributes found in views.')
