time_A2B, time_B2C = input("Enter hhmmss_A2B hhmmss_B2C : ").split()
  
hh1 = (int(time_A2B)%1000000)//10000
mm1 = (int(time_A2B)%10000)//100
ss1 = (int(time_A2B)%100)

hh2 = (int(time_B2C)%1000000)//10000
mm2 = (int(time_B2C)%10000)//100
ss2 = (int(time_B2C)%100)

s_total  = (ss1 + ss2)%60
quotient = (ss1 + ss2)//60

m_total  = (mm1 + mm2 + quotient)%60
quotient = (mm1 + mm2 + quotient)//60

h_total  = hh1 + hh2 + quotient

print('---A to B---')
print('hour   = %d' %hh1)
print('minute = %d' %mm1)
print('second = %d' %ss1)
print('---B to C---')
print('hour   = %d' %hh2)
print('minute = %d' %mm2)
print('second = %d' %ss2)
print('---A to C---')
print('hour   = %d' %h_total)
print('minute = %d' %m_total)
print('second = %d' %s_total)