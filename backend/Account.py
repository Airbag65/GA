import functions
import time

class Account:
    def __init__(self, account: dict):
        self.account = account
        self.select_account = functions.select_account(self.account)[0]

    def login(self):
        first_name = self.select_account["first_name"]
        if self.select_account["token"] == "":
            functions.generate_token(self.account)
            self.select_account = functions.select_account(self.account)[0]
        enter_pass_token = input("Säkerhetsnyckel: ")
        if self.select_account["token"] == enter_pass_token:
            print("Loggar in...")
            time.sleep(1)
            print(f"Välkommen {first_name}")
        else:
            print("Fel säkerhetsnyckel")

