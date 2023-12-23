from operator import *
class StackCalc:
  def __init__(self):
    self.s = [0]
    binop = lambda op: lambda: self.s.append(op(self.s.pop(), self.s.pop()))
    self.ops = {
      '*': binop(mul),
      '/': binop(floordiv),
      '+': binop(add),
      '-': binop(sub),
      'DUP': lambda: self.s.append(self.s[-1]),
      'POP': self.s.pop
    }
  def run(self, instructions):
    for x in instructions.split():
      if x in self.ops:
        self.ops[x]()
      else:
        try: self.s.append(int(x))
        except:
          self.s = ["Invalid instruction: " + x]
          break
  def getValue(self):
    return self.s[-1]
print("* Stack Calculator *")
arg = input("Enter arguments : ")
machine = StackCalc()
machine.run(arg)
print(machine.getValue())