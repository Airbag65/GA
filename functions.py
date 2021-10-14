from uuid import uuid4
import json


def select_account(username:str) -> dict:
    with open ("accounts.json") as read_json:
        data = json.load(read_json)
        read_json.close()
    accounts = data['accounts']
    selected_account = ""
    index = 0
    for account in accounts:
        if account["username"] == username:
            selected_account = account
            break
        index += 1
    if selected_account != "":
        return selected_account, index
    else:
        return {"no-account": "no account found"}, 0


def generate_token(username:str) -> None:
    token = uuid4()
    with open ("accounts.json") as read_json:
        data = json.load(read_json)    
        read_json.close()
    data["accounts"][select_account(username)[1]]["token"] = str(token)
    new_data = data
    write_json = open("accounts.json", "w+")
    write_json.write(json.dumps(new_data, indent=4, sort_keys=True))
    write_json.close()
    print(f"In inloggningsnyckel är: {str(token)}")