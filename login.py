import generate_token
import time

class Account:
    def __init__(self, account: dict):
        self.account = account
        self.select_account = generate_token.select_account(self.account)[0]


if __name__ == "__main__":
    account_username = input("Ange användarnamn: ")
    konto = Account(account_username)
    # TODO Säkerställa att konto med användarnamn finns
    first_name = konto.select_account["first_name"]
    enter_pass_token = input("Säkerhetsnyckel: ")
    if konto.select_account["token"] == enter_pass_token:
        print("Loggar in...")
        time.sleep(1)
        print(f"Välkommen {first_name}")
    else:
        print("Fel säkerhetsnyckel")
        
    
