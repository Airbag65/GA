import secrets
from uuid import uuid4
import json

token = uuid4()
token1 = secrets.token_bytes(16)


def select_account(username):
    with open ("accounts.json") as json_file:
        data = json.load(json_file)
    accounts = data['accounts']
    selected_account = ""
    index = 0
    for account in accounts:
        if account["username"] == username:
            selected_account = account
            break
        index += 1
    return selected_account, index


def generate_token(username):
    token = uuid4()
    with open ("accounts.json") as json_file:
        data = json.load(json_file)    
        json_file.close()
    data["accounts"][select_account(username)[1]]["token"] = str(token)
    new_data = data
    write_json = open("accounts.json", "w+")
    write_json.write(json.dumps(new_data, indent=4, sort_keys=True))
    write_json.close()
    print(f"In inloggningsnyckel är: {str(token)}")
        

if __name__ == "__main__":
    account_to_target = input("Ange användarnamn: ")
    generate_token(account_to_target)