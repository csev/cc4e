lst = list();
lst.append("Hello world");
print(lst)
lst.append("Catch phrase");
print(lst)
lst.append("Brian");
print(lst)
print("Length =", len(lst));

print("Brian?", lst.index("Brian"));

if "Bob" in lst:
    print("Bob?", lst.index("Bob"));
else:
    print("Bob? 404");

# To start a fight on StackOverflow, ask this:
# https://stackoverflow.com/questions/8197323/list-index-function-for-python-that-doesnt-throw-exception-when-nothing-found
# https://stackoverflow.com/questions/5125619/why-doesnt-list-have-safe-get-method-like-dictionary

