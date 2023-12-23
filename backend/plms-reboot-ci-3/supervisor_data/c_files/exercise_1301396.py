one_hundred_usd, fifty_usd, twenty_usd, ten_usd, five_usd, one_us = input("Enter USD banknote : ").split()

cash_in_us = 100*float(one_hundred_usd) + 50*float(fifty_usd) + 20*float(twenty_usd) + 10*float(ten_usd) + 5*float(five_usd) + float(one_us)
cash_in_th = 32.31*(100*float(one_hundred_usd) + 50*float(fifty_usd)) + 31.9*(20*float(twenty_usd) + 10*float(ten_usd) + 5*float(five_usd)) + 31.52*float(one_us)

cash_in_th = cash_in_th//1

print('--------exchange--------')
print('%f USD to %f THB' %(cash_in_us,cash_in_th))

one_thousand_thb = cash_in_th//1000
cash_in_th       = cash_in_th%1000

five_hundred_thb = cash_in_th//500
cash_in_th       = cash_in_th%500

one_hundred_thb = cash_in_th//100
cash_in_th      = cash_in_th%100

fifty_thb  = cash_in_th//50
cash_in_th = cash_in_th%50

ten_thb    = cash_in_th//10
cash_in_th = cash_in_th%10

five_thb   = cash_in_th//5
one_thb    = cash_in_th%5

print('--------current THB banknote--------')
print('%d one-thousand bills' %one_thousand_thb)
print('%d five-hundred bills' %five_hundred_thb)
print('%d one-hundred bills' %one_hundred_thb)
print('%d fifty bills' %fifty_thb)

print('--------current THB Coins--------')
print('%d ten coins' %ten_thb)
print('%d five coins' %five_thb)
print('%d one coins' %one_thb)
