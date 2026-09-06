import os, re
keywords = ['testimonial','review','feedback','"amazing"','"best"','"life-changing"','"100%"','"guaranteed"','#1','world\'s best']
for root, dirs, files in os.walk('resources/views'):
    for f in files:
        if f.endswith('.blade.php'):
            p = os.path.join(root, f)
            with open(p, 'r', errors='ignore') as file:
                content = file.read()
                for k in keywords:
                    if k in content.lower():
                        print(p + ' contains: ' + k)
                        break
