import os, re
issues = []
for root, dirs, files in os.walk('resources/views'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                imgs = re.findall(r'<img[^>]*>', content, re.S)
                for img in imgs:
                    if 'alt=' not in img:
                        issues.append(p + ' missing alt')
                    else:
                        m = re.search(r'alt=["\'](.+?)["\']', img)
                        if m:
                            alt = m.group(1).strip()
                            if alt == '' or alt.lower() in ['image','photo','pic','logo','icon']:
                                issues.append(p + ' generic alt: ' + alt)
print('Issues found: ' + str(len(issues)))
for i in issues[:10]: print(i)
if not issues: print('No alt issues.')
