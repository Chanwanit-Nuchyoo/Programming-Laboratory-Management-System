class TorKham:
	def __init__(self):
		self.words = []
	def restart(self):
		self.__init__()
		return "game restarted"
	def play(self, word):
		if self.words == [] or (word.lower() not in [str(i).lower() for i in self.words] and word[0:2].lower() == self.words[-1][-2:].lower()):
			self.words.append(word)
			return self.words
		return "game over"

torkham = TorKham()
print("*** TorKham HanSaa ***")

S = input("Enter Input : ").split(',')
for s in S:
    if s[0] not in ["P", "R", "X"]:
        print("\'{0}\' is Invalid Input !!!".format(s))
        break
    if s[0] == "P":
        words = torkham.play(s.split()[1])
        print("\'{0}\' -> {1}".format(s.split()[1], words))
        if words == "game over":
            break
    elif s[0] == "R":
        print(torkham.restart())
    elif s[0] == "X":
        break