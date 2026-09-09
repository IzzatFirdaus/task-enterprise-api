import os, re
tracks = ['googletagmanager','google-analytics','gtag','fbq','meta pixel','analytics.js','tracking']
for root, dirs, files in os.walk('resources'):
    for f in files:
        if f.endswith('.blade.php') or f.endswith('.html'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                for t in tracks:
                    if t in content.lower():
                        print(p + ' has tracking: ' + t)
