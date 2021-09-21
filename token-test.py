import secrets
from uuid import uuid4

token = uuid4()
token1 = secrets.token_bytes(16)

print(token)
