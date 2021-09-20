import secrets
import uuid

token = uuid.uuid4()
token1 = secrets.token_bytes(16)

print(token)
