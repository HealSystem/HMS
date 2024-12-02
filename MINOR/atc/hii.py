class Statement:
    def _init_(self, line):
        self.line = line
        self.type = self.parse_type()  # Identify statement type

    def parse_type(self):
        # Identify statement type based on patterns
        line_lower = self.line.lower()
        if "=" in self.line and not any(keyword in line_lower for keyword in ["for", "while", "if"]):
            return "assignment"
        elif line_lower.startswith("print"):
            return "print"
        elif line_lower.startswith("read"):
            return "read"
        elif line_lower.startswith("if"):
            return "if"
        elif line_lower.startswith("else"):
            return "else"
        elif line_lower.startswith("while"):
            return "while"
        elif line_lower.startswith("do"):
            return "do"
        elif line_lower.startswith("for"):
            return "for"
        elif line_lower.startswith("switch"):
            return "switch"
        elif line_lower.startswith("case"):
            return "case"
        elif line_lower.startswith("default"):
            return "default"
        elif line_lower.startswith("end"):
            return "end"
        return "unknown"

    def to_c(self):
        # Generate C code based on statement type
        if self.type == "assignment":
            var, value = self.line.split("=")
            return f"{var.strip()} = {value.strip()};"
        elif self.type == "print":
            var = self.line.split()[1]
            return f'printf("{var} = %d\\n", {var});'
        elif self.type == "read":
            var = self.line.split()[1]
            return f'scanf("%d", &{var});'
        elif self.type == "if":
            condition = self.line[3:].strip()
            return f"if ({condition}) {{"
        elif self.type == "else":
            return "} else {"
        elif self.type == "while":
            condition = self.line[6:].strip()
            return f"while ({condition}) {{"
        elif self.type == "do":
            return "do {"
        elif self.type == "for":
            loop_header = self.line[4:].strip()
            return f"for ({loop_header}) {{"
        elif self.type == "switch":
            expression = self.line[7:].strip()
            return f"switch ({expression}) {{"
        elif self.type == "case":
            value = self.line[4:].strip()
            return f"case {value}:"
        elif self.type == "default":
            return "default:"
        elif self.type == "end":
            return "}"
        return ""  # Handle unknown statements

def parse_algorithm(algorithm):
    ir = []
    lines = algorithm.strip().split("\n")
    for line in lines:
        ir.append(Statement(line.strip()))
    return ir

def generate_c_code(ir):
    code = "#include <stdio.h>\n\nint main() {\n"
    variables = set()
    indent_level = 1  # To manage the indentation of code blocks
    indent = "    "  # 4 spaces for each indent level

    # First pass to collect variable names
    for statement in ir:
        if statement.type == "assignment":
            var = statement.line.split("=")[0].strip()
            variables.add(var)

    # Declare all variables at the beginning of the main function
    for var in variables:
        code += indent + f"int {var};\n"

    # Second pass to generate the C code
    for statement in ir:
        c_code = statement.to_c()
        if c_code:  # Only add non-empty lines
            if statement.type == "end" and code.endswith("}\n"):
                indent_level -= 1
            code += indent * indent_level + c_code + "\n"
            if statement.type in {"if", "else", "while", "do", "for", "switch"}:
                indent_level += 1
            elif statement.type == "case" or statement.type == "default":
                code += indent * (indent_level + 1) + "break;\n"
            if statement.type == "end" and not code.endswith("}\n"):
                code += indent * (indent_level - 1) + "}\n"
                indent_level -= 1

    code += indent + "return 0;\n}"
    return code

def algorithm_to_c_code(algorithm):
    ir = parse_algorithm(algorithm)
    return generate_c_code(ir)

# Example Usage
algorithm = """
x = 5
y = 10
read a
if a > 5
    x = x + a
else
    y = y + a
end
while x < 20
    x = x + 1
    print x
end
do
    x = x - 1
    print x
while x > 10
end
for i = 0; i < 10; i = i + 1
    print i
end
switch x
    case 5
        print x
    case 10
        print y
    default
        print z
end
z = x + y
print z
"""

c_code = algorithm_to_c_code(algorithm)
print("C Code:\n", c_code)