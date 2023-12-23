<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>codemirror_test</title>
    <script  type="text/javascript" src="https://python.compro.kmitl.ac.th/compro22s1/assets/codemirror-5.22.0/lib/codemirror.js"></script>
    <link rel="stylesheet" type="text/css" href="https://python.compro.kmitl.ac.th/compro22s1/assets/codemirror-5.22.0/lib/codemirror.css" >
    <script  type="text/javascript" src="https://python.compro.kmitl.ac.th/compro22s1/assets/codemirror-5.22.0/mode/python/python.js"></script>
    <link rel="stylesheet" type="text/css" href="https://python.compro.kmitl.ac.th/compro22s1/assets/css/style_k.css" >
</head>
<body>
    <div>Test CodeMirror</div>
<div id="sourcecode_wrapper" style="display:block;background-color:cyan;">
<textarea id="sourcecode_content" class="CodeMirror" style="text-align:left;padding:10px;margin:10px;" readonly>'''
 * กลุ่มที่  : 21010099
 * 65991234 นัชฌา ผิงผิง
 * chapter : 2	item : 1	ครั้งที่ : 0017
 * Assigned : Sunday 28th of August 2022 02:16:27 PM --> Submission : Monday 29th of August 2022 08:31:48 AM	
 * Elapsed time : 1095 minutes.
 * filename : Quiz1-2.py
'''
str=input("Enter USD banknote : ")
#print(str,type(str))
a,b,c,d,e,f = str.split()
#print(f'a={a} b={b} c={c} d={d} e={e} f={f}')
a = int(a)  # 100
b = int(b)  # 50
c = int(c)  # 20
d = int(d)  # 10
e = int(e)  # 5
f = int(f)   # 1
usd = a*100 + b*50 + c*20 + d*10 + e*5 + f*1
#print("usd=",usd)
thai = (a*100+b*50)*32.31 + (c*20 + d*10 + e*5)*31.9 + f*31.52
#print("thai=",thai)
print("--------exchange--------")
thai = int(thai)
print(f'{usd:.6f} USD to {thai:.6f} THB')
print("--------current THB banknote--------")
print(f'{thai//1000:0.0f} one-thousand bills')
thai = thai%1000 
print(f'{thai//500:0.0f} five-hundred bills')
thai = thai%500
print(f'{thai//100:0.0f} one-hundred bills')
thai = thai%100
print(f'{thai//50:0.0f} fifty bills')
thai = thai%50
print("--------current THB Coins-------")
print(f'{thai//10:0.0f} ten coins')
thai = thai%10
print(f'{thai//5:0.0f} five coins')
thai = thai%5
print(f'{thai//1:0.0f} one coins')
</textarea>
</div>
<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					readonly: true,
					mode: "text/python",
                    autofocur:true
			});
	</script>
</body>
</html>

	
	