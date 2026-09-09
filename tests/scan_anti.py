import os
patterns = ['gradient','bg-gradient','from-violet','from-fuchsia','glassmorphism','font-[\'\"]Inter','font-[\'\"]Space Grotesk','font-[\'\"]Instrument Serif']
found = False
for root, dirs, files in os.walk('resources'):
    for f in files:
        if f.endswith('.blade.php') or f.endswith('.css') or f.endswith('.js'):
            p = os.path.join(root, f)
            try:
                with open(p, 'r', errors='ignore') as file:
                    content = file.read()
                    for pat in patterns:
                        if pat.lower() in content.lower():
                            print(f'{p}: contains {pat}')
                            found = True
            except Exception as e:
                pass
if not found:
    print('No anti-pattern gradient/font patterns found.')
