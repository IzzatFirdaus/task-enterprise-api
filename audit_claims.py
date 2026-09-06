import os, re
claims = ['100% guaranteed','#1 in the world','best in class','world-class','unbeatable','instant results','guaranteed success','never fails']
for root, dirs, files in os.walk('resources/views/public'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                for c in claims:
                    if c in content.lower():
                        print(p + ' has claim: ' + c)
