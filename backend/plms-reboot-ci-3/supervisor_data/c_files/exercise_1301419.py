raw_input = input("Enter query name and guest list: ").split()
query = raw_input[0].lower()
lst = raw_input[1:]
print(" --- searching ---");
for name in lst:
    if query == name.lower():
        print("Welcome, you're on the list!",query.capitalize())
        quit()
print("Sorry, you're not on the list!",query.capitalize())
