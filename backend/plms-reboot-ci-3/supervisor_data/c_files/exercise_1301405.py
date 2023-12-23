def greet(name):
    print('Hello', name)

print(" *** Greeting ***")
names = input('Enter some names: ').split()
print(names)
for name in names:
    greet(name)
