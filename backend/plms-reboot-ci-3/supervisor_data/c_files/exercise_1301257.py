from math import log2
from math import floor
def print90(h,i=0):
    max_i = len(h)
    if i < max_i:
        indent = floor(log2(i+1))
        print90(h, (i*2)+2)
        print('   ' * indent, h[i])
        print90(h, (i*2)+1)

class Max_Heap:
    def __init__(self, arr=[]):
        self._heap = []
        if arr is not None:
            for e in arr:
                self.push(e)

    def push(self, value):
        self._heap.append(value)
        # Calling the bottom_up() to ensure heap is in order.
        # here we are passing our heap 
        self._bottom_up(len(self) - 1)

    def pop(self):
        root="Heap is empty"
        if len(self._heap)!=0:
        # swapping the root value with the last value.
            _swap(self._heap, len(self) - 1, 0)

        # storing the popped value in the root variable
            root = self._heap.pop()

        #Calling the top_down function to ensure that the heap is still in order 
            self._top_down(0)

        return root

    def __len__(self):
        return len(self._heap)

    def peek(self):
        if len(self._heap)!=0:
            return(self._heap[0])
        else:
            return("heap is empty")
    
     # This is a private function used for traversing up the tree and ensuring that heap is in order
    def _bottom_up(self,index):
        # Finding the root of the element
        root_index = (index - 1) // 2
        
        # If we are already at the root node return nothing
        if root_index < 0:
            return

        # If the current node is greater than the root node, swap them
        if self._heap[index] > self._heap[root_index]:
            _swap(self._heap, index,root_index)
        # Again call bottom_up to ensure the heap is in order
            self._bottom_up(root_index)

    # This is a private function which ensures heap is in order after root is popped
    def _top_down(self, index):
        child_index = 2 * index + 1
        # If we are at the end of the heap, return nothing
        if child_index >= len(self._heap):
            return

        # For two children swap with the larger one , เลือกลูกซ้ายหรือขวา
        if child_index + 1 < len(self._heap) and self._heap[child_index] < self._heap[child_index + 1]:
            child_index += 1

        # If the child node is smaller than the current node, swap them
        if self._heap[child_index] > self._heap[index]:
            _swap(self._heap, child_index, index)
            self._top_down(child_index)

class Min_Heap:
    def __init__(self, arr=[]):
        self._heap = []
        if arr is not None:
            for e in arr:
                self.push(e)

    def push(self, value):
        self._heap.append(value)
        # Calling the bottom_up() to ensure heap is in order.
        # here we are passing our heap 
        self._bottom_up(len(self) - 1)

    def pop(self):
        root="Heap is empty"
        if len(self._heap)!=0:
        # swapping the root value with the last value.
            _swap(self._heap, len(self) - 1, 0)

        # storing the popped value in the root variable
            root = self._heap.pop()

        #Calling the top_down function to ensure that the heap is still in order 
            self._top_down(0)

        return root

    def __len__(self):
        return len(self._heap)

    def peek(self):
        if len(self._heap)!=0:
            return(self._heap[0])
        else:
            return("heap is empty")
    
     # This is a private function used for traversing up the tree and ensuring that heap is in order
    def _bottom_up(self,index):
        # Finding the root of the element
        root_index = (index - 1) // 2
        
        # If we are already at the root node return nothing
        if root_index < 0:
            return

        # If the current node is greater than the root node, swap them
        if self._heap[index] < self._heap[root_index]:
            _swap(self._heap, index,root_index)
        # Again call bottom_up to ensure the heap is in order
            self._bottom_up(root_index)

    # This is a private function which ensures heap is in order after root is popped
    def _top_down(self, index):
        child_index = 2 * index + 1
        # If we are at the end of the heap, return nothing
        if child_index >= len(self._heap):
            return

        # For two children swap with the larger one , เลือกลูกซ้ายหรือขวา
        if child_index + 1 < len(self._heap) and self._heap[child_index] > self._heap[child_index + 1]:
            child_index += 1

        # If the child node is smaller than the current node, swap them
        if self._heap[child_index] < self._heap[index]:
            _swap(self._heap, child_index, index)
            self._top_down(child_index)
# Swaps value in heap between i and j index
def _swap(L, i, j):
    L[i], L[j] = L[j], L[i]


def runningMedian(a,i=0,median=0,max_heap=Max_Heap(),min_heap=Min_Heap()):
    if i == 0:
        median = a[0]
        print("list =",a[:1],": median =",float(median))
        runningMedian(a,i+1)
    elif i<len(a):
        if len(min_heap) == 0 and len(max_heap) == 0:
            if a[i-1] > a[i]:
                max_heap.push(a[i])
                min_heap.push(a[i-1])
            else:
                max_heap.push(a[i-1])
                min_heap.push(a[i])
            median = (a[i-1]+a[i])/2
            print("list =",a[:i+1],": median =",float(median))
            runningMedian(a,i+1,median,max_heap,min_heap)
        else:
            if a[i] > median:
                min_heap.push(a[i])
            else:
                max_heap.push(a[i])


            if len(min_heap)-len(max_heap) > 1:
                max_heap.push(min_heap.pop())
            elif len(max_heap)-len(min_heap) > 1:
                min_heap.push(max_heap.pop())
    
            if len(min_heap) == len(max_heap):
                median=(min_heap.peek()+max_heap.peek())/2
            elif len(min_heap) > len(max_heap):
                median = min_heap.peek()
            else:
                median = max_heap.peek()

            print("list =",a[:i+1],": median =",float(median))
            
            runningMedian(a,i+1,median,max_heap,min_heap)



l = [e for e in input("Enter Input : ").split()]
if l[0] == 'EX':
    Ans = "minHeap and maxHeap"
    print("Extra Question : What is a suitable sort algorithm?")
    print("   Your Answer : "+Ans)
else:
    l=list(map(int, l))
    median = 0
    # Calling function
    runningMedian(l)