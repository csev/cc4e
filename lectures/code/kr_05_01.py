
# https://stackoverflow.com/questions/15011674/is-it-possible-to-dereference-variable-ids
# https://stackoverflow.com/a/15012814/1994792
# The id() function is not intended to be dereferenceable; the fact that it is based on the
# memory address is a CPython implementation detail, that other Python implementations do not follow.

import _ctypes

def deref(obj_id):
    """ Inverse of id() function. """
    return _ctypes.PyObj_FromPtr(obj_id)

x = 42
px = id(x)
print("%d 0x%x" % (x,px))

y = deref(px)
print("%d 0x%x %d" % (x,px,y))
