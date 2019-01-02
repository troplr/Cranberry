# TODO

* Everything

---

## STRUCTURE PLAN

```
(Project Root)

DNL/ - (my) Micro library
Website/ - classes related to the macro build process of a website
--Website - static procedural code for building website
--BuildSettings - static parses __site.json and stores its fields in public static vars
--CodeBlockParser - splits the input into code blocks and runs the respective CLoop
Content/ - classes related to website structure
--Variable/ - classes related to content variables
----CVariable - class that represents a variable to search for in text and what to replace it with
----CVManager - class static that can "register" cvariables, then run all of them on input text
----CVList - class static that holds all default cvariables, registers them
--Loop/ - classes related to content loops
----CLoop - class that represents the name of a loop, its parameters, its body, and its function
----CLManager - see CVManager
----CLList - see CVList
--Page - class that represents a page and the information associated with it
--Post extends Page - class that represents a post and the information associated with it
--Blog - statically manages the blog
Program - entry point, read __site.json
CLIArgs - handle CLI args
```
