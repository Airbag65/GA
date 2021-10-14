import generate_token
import time

class Account:
    def __init__(self, account: dict):
        self.account = account
        self.select_account = generate_token.select_account(self.account)[0]

    def login(self):
        pass

if __name__ == "__main__":
    account_username = input("Ange användarnamn: ")
    if generate_token.select_account(account_username)[0] != {"no-account": "no account found"}:
        konto = Account(account_username)
    else:
        print(f"Hittade inget konto med användarnamn: {account_username}")
        konto = None
    
    if konto != None:
        first_name = konto.select_account["first_name"]
        enter_pass_token = input("Säkerhetsnyckel: ")
        if konto.select_account["token"] == enter_pass_token:
            print("Loggar in...")
            time.sleep(1)
            print(f"Välkommen {first_name}")
        else:
            print("Fel säkerhetsnyckel")

    
