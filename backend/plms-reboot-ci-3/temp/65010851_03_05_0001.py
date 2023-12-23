'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 5	ครั้งที่ : 0001
 * Assigned : Monday 15th of August 2022 07:38:14 PM --> Submission : Monday 15th of August 2022 09:38:05 PM	
 * Elapsed time : 119 minutes.
 * filename : ch3_5.py
'''
print(" *** Transform second ***")
s = input("Enter seconds : ")
s = int(s)
w,d,h,m = 0,0,0,0
if s>604800 :
    w = s//604800
    a = s-604800*w
if a>86400 :
    d = a//86400
    a = a-86400*d
if a>3600 :
    h = a//3600
    a = a-3600*h
if a>60 :
    m = a//60
    a = a-60*m
if w==0 :
    print(s,"seconds ==>",d,"days",h,"hours",m,"minutes",s,"seconds")

if d==0 :
    print(s,"seconds ==>",w,"weeks",h,"hours",m,"minutes",a,"seconds")

if h==0 :
    print(s,"seconds ==>",w,"weeks",d,"days",m,"minutes",a,"seconds")

if m==0 :
    print(s,"seconds ==>",w,"weeks",d,"days",h,"hours",a,"seconds")

if s==0 :
    print(s,"seconds ==>",w,"weeks",d,"days",h,"hours",m,"minutes")
else :
    print(s,"seconds ==>",w,"weeks",d,"days",h,"hours",m,"minutes",a,"seconds")