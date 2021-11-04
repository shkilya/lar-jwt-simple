### Generate JWT keys
```bash
openssl req -newkey rsa:2048 -new -nodes -x509 -days 3650 -keyout "storage/oauth-private.key" -out "storage/oauth-public.key"
```
```bash
sudo chown www-data:www-data storage/oauth-private.key
```
