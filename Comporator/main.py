"""
The algorithm implemented here is based on "An O(NP) Sequence Comparison Algorithm"                                   
by described by Sun Wu, Udi Manber and Gene Myers 
"""

import sys

def editdistance(a, b):
    m = len(a)
    n = len(b)
    if m >= n:
        a, b = b, a
        m, n = n, m
    offset = m + 1
    delta  = n - m
    size   = m + n + 3
    fp = [ -1 for idx in range(size) ]
    p = -1
    while (True):
        p = p + 1
        print "INDEX=%s" % (p)
        for k in range(-p, delta, 1):
            print "SHIFT=%s" % (k)
            fp[k+offset] = snake(a, b, m, n, k, fp[k-1+offset]+1, fp[k+1+offset])
            print fp
        for k in range(delta+p, delta, -1):
            print "SHIFT_DELTA=%s" % (k)
            fp[k+offset] = snake(a, b, m, n, k, fp[k-1+offset]+1, fp[k+1+offset])
            print fp
        print "DELTA=%s" % (delta)
        fp[delta+offset] = snake(a, b, m, n, delta, fp[delta-1+offset]+1, fp[delta+1+offset])
        print fp
        print "DELTA_POSITION=%s AND INDEX=%s" % (delta+offset, p)
        if fp[delta+offset] >= n: break
    return delta + 2 * p
    
def snake(a, b, m, n, k, p, pp):
    y = max(p, pp)
    x = y - k
    print "MAX_POSITION=%s AND SHIFT=%s" % (y, k)
    while x < m and y < n and a[x] == b[y]:
        x = x + 1
        y = y + 1
    return y

if __name__ == "__main__":
    print editdistance(sys.argv[1], sys.argv[2])
