args = input('Please enter total price of the purchased items: ')
try:
    price = float(args)
except ValueError:
    print('Invalid input')
    exit(1)
if price >= 1500:
    price *= 0.9
elif price >= 800:
    price -= 50
print('Discounted price = %.2f' % (price))
