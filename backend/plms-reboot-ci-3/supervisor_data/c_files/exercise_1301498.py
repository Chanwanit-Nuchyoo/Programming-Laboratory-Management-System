def findWord(text,word):
    count = 0
    for w in text.split():
        if (w==word):
            count += 1
    return count
text1 = '''Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non ante quam. Pellentesque tempus porta ante nec vehicula. Phasellus vel ligula in magna pulvinar consectetur. Ut sollicitudin tristique erat sed congue. Proin sollicitudin luctus felis sit amet sagittis. Sed iaculis vel nulla eu facilisis. In quis hendrerit urna, ac lobortis justo. Mauris lacinia sodales convallis. Nunc tempus feugiat dolor, id egestas justo semper ut. Nulla a consectetur tellus. Donec at nulla laoreet, efficitur erat nec, feugiat risus. Sed laoreet dignissim elementum. Quisque eget elit nec ex tempor elementum sed non libero. Nunc ullamcorper facilisis dolor, eget egestas ante tincidunt vitae.'''

print(" *** find word ***")
word = input("Enter a word : ")
#print(text1)
print(word,"==>",findWord(text1,word))