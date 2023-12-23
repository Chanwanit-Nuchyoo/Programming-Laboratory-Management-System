def final_countdown(lst):
	res=[[lst[0]]] if lst else []
	for i in range(1,len(lst)):
		if lst[i-1]-lst[i]==1 and lst[i]!=0:res[-1]+=[lst[i]]
		else:res+=[[lst[i]]]
	res=[i for i in res if i[-1]==1]
	return [len(res),res]
    
print('*** Fun with countdown ***')
lst = [int(i) for i in input('Enter List : ').split()]
print(final_countdown(lst))