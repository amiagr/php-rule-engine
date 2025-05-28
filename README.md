# 📌 PHP Rule Engine – Roadmap / To-Do List

---

## ✅ Validation & Core Logic

- [x] Validate new data on definition
- [ ] Validate loaded data from persistent storage
- [ ] Save rules in database with migration system
- [x] Auto-generate hash as name for unnamed rules

---

## ⚙️ Operators & Rule Enhancements

- [ ] `startsWith` string comparison
- [ ] `endsWith` string comparison
- [ ] `contains` value
- [ ] `notContains` value
- [ ] `inArray` support
- [ ] `notInArray` support
- [ ] `regex` match support
- [ ] `distance` calculation (GEO location, date difference, etc.)
- [ ] Date comparisons:
    - `startOfDay`, `endOfDay`
    - `startOfMonth`, `endOfMonth`
    - `startOfYear`, `endOfYear`, etc.

---

## 🔥 Performance & System

- [ ] Add caching layer for rule evaluation performance
- [ ] Advanced logging & debugging system
- [ ] Export internal types and enums for easier type-safe integration

---

## ✨ Developer Experience

- [ ] DSL (Domain Specific Language) for writing rules in a human-readable format  
  _e.g._: `if user.age >= 18 and user.country == "Canada"`
- [ ] GUI for rule creation and management
- [ ] Full documentation with examples and integration guides
- [ ] Publish as open-source package (Packagist, Composer)

---

## ⏰ Smart Rule Execution

- [ ] Scheduled Rules (rules that run on defined cron/timer intervals)
- [ ] Event-Driven Rules (rules triggered on custom application events)

---

Feel free to contribute or suggest more ideas via [Issues](../../issues)!

R&D: custom (php artisan make::rule)