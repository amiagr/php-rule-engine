# 📋 PHP Rule Engine – Next Steps / To-Do

A step-by-step checklist to implement a complete, user-friendly API:

---

## 1. Configuration & Initialization
- [ ] Add factory methods to `RuleEngine` class:
    - `static withFile(string $path, bool $debug = false): self`
    - `static withDatabase(PDO|Connection $conn, bool $debug = false): self`
    - `static inMemory(bool $debug = false): self`
- [ ] Handle constructor options (`debug`, `persist`, `file`/`db` details)

---

## 2. Rule Definition & Management
- [ ] `defineRule(array $definition): RuleInterface`
- [ ] `defineRuleSet(string $name, array $definitions): void`
- [ ] `updateRuleSet(string $name, array $newDefinitions): void`
- [ ] `deleteRule(string $name): bool`
- [ ] `listRules(): array`

---

## 3. Rule Loading
- [ ] `loadRules(): array`  (load all definitions from file or database)
- [ ] `getRule(string $name): array`  (retrieve a specific definition)

---

## 4. Evaluation
- [ ] `evaluateRule(array $definition, array $input, array $options = []): bool|array`
- [ ] `evaluate(string $name, array $input, array $options = []): bool|array`
    - [ ] Support returning only `bool` or `['result'=>bool,'details'=>…]` in debug mode

---

## 5. Options & Extensibility
- [ ] Additional evaluate options (`context`, `traceId`, metadata)
- [ ] `registerLoader(RuleLoaderInterface $loader): void`
- [ ] `registerValidator(RuleDefinitionValidatorInterface $validator): void`

---

## 6. Convenience Helpers
- [ ] Create a CLI entrypoint (`bin/rule-engine`) with subcommands:
    - `define`
    - `evaluate`
    - `list`
    - `delete`
- [ ] (Optional) Provide a global helper function `rule_engine()`

---

Once each item is completed, we’ll be one step closer to an official Packagist release.  
