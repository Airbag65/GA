from Account import Account
import functions

if __name__ == "__main__":
    account_username = input("Ange användarnamn: ")
    if functions.select_account(account_username)[0] != {"no-account": "no account found"}:
        konto = Account(account_username)
    else:
        print(f"Hittade inget konto med användarnamn: {account_username}")
        konto = None
    
    if konto != None:
        konto.login()