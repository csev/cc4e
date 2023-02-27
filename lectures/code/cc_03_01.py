import math

class PointClass:
    def __init__(self, x, y):
        self.x = x
        self.y = y
        
    def dump(self):
        print('Object point@%x x=%f y=%f' % (id(self),self.x,self.y))

    def origin(self):
        return math.sqrt(self.x*self.x+self.y*self.y)
        
pt = PointClass(4.0, 5.0)
PointClass.dump(pt)
print('Origin',PointClass.origin(pt))

pt.dump()
print('Origin',pt.origin())

del(pt)

