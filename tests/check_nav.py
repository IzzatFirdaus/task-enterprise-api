import re
with open('routes/web.php') as f: content = f.read()
routes = set(re.findall(r"Route::get\('(.+?)'", content))
with open('resources/views/layouts/app.blade.php') as f: html = f.read()
links = set(re.findall(r"route\('(.+?)'\)", html))
missing = [l for l in links if l not in routes and not l.startswith('admin.') and not l.startswith('profile.')]
print('Nav links:', sorted(links)[:12])
print('Missing/common:', sorted(missing)[:8])
