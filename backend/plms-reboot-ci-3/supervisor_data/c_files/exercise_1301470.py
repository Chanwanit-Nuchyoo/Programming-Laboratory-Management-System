T = ("Fusce", "vehicula", "mattis", "eleifend", "condimentum", "nisl", "sit", "amet", "magna", "semper", "pharetra", "Proin", "aliquet", "magna", "non", "dapibus", "blandit", "Quisque", "nibh")
w = input(" *** Tuple Search ***\nEnter a word : ")
print("\nIndex of word '{}' is {}".format(w, T.index(w))) if w in T else print("\nWord '{}' not found in Tuple".format(w))