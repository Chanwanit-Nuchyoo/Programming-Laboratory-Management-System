cash, usd_exchange = input("Enter cash rate : ").split()
  
cash_in_us = float(cash)//float(usd_exchange)
cash_in_th = cash_in_us*float(usd_exchange)

print('--------exchange--------')
print('%f THB to %f USD' %(cash_in_th,cash_in_us))
  
one_hundred_usd = cash_in_us//100
cash_in_us      = cash_in_us%100

fifty_usd  = cash_in_us//50
cash_in_us = cash_in_us%50

twenty_usd = cash_in_us//20
cash_in_us = cash_in_us%20

ten_usd    = cash_in_us//10
cash_in_us = cash_in_us%10

five_usd   = cash_in_us//5
one_us     = cash_in_us%5

print('--------current USD banknote--------')
print('%d one-hundred bills' %one_hundred_usd)
print('%d fifty bills' %fifty_usd)
print('%d twenty bills' %twenty_usd)
print('%d ten bills' %ten_usd)
print('%d five bills' %five_usd)
print('%d one bills' %one_us)