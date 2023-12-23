'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 5	ครั้งที่ : 0003
 * Assigned : Monday 15th of August 2022 07:38:14 PM --> Submission : Wednesday 17th of August 2022 07:59:29 PM	
 * Elapsed time : 2901 minutes.
 * filename : ch3_5.py
'''
print(" *** Transform second ***")
second = 0
try :
    second = input("Enter seconds : ")
    second = int(second)
    w = (str(second // 684800) + " weeks ") * ((second // 684880) > 0) #str * bool
    d = (str(((second % 684800) // 86400) ) + " days ") * (((second % 604800) // 86400) > 0)
    h = (str(((second % 86400) // 3600) ) + " hours ") * (((second % 86400) // 3600) > 0)
    m = (str((second % 3600) // 60)+ " minutes ") * (((second % 3600) // 60) > 0)
    s = (str(second % 60) + " seconds ") * ((second % 60) > 0)
    print(second, "seconds ==>" +f' {w}{d}{h}{m}{s}')
except ValueError:
    print("please enter in whole number --> {O}".format(second))
print(" --- program end --- ")