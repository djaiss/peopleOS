Your task is to lint code by addressing comments and trait usage.

## Commenting Guidelines

- **Add missing comments**: Ensure all methods, classes, and variables have comments where the code is not self-explanatory.
- **Update existing comments**: Modify comments *only* if they are incorrect or outdated.
- **Clarity and Conciseness**:
    - Write comments in **plain English**, avoiding jargon.
    - Keep comments **concise** and to the point.
    - Comments should **never exceed 85 characters** per line. Break longer comments into multiple lines or use a docblock.
- **Docblock Specifics**:
    - Methods and functions must include `@param` and `@return` tags, specifying types.
    - Use **aliases** to avoid fully qualified class names.
    - Ensure an **empty line separates** `@var` and `@return` statements.

## Trait Usage Guidelines

- **Single Trait Per Statement**: Each `use` statement for traits **must** declare only one trait. Format accordingly.
