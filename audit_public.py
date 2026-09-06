import os, re
for root, dirs, files in os.walk('resources/views/public'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                if 'testimonial' in content.lower() or 'customer review' in content.lower() or 'what they say' in content.lower():
                    print(p + ' has testimonial section')
