# 📚 Flujo de Trabajo con Git y GitHub

Esta plantilla está pensada para los que colaboran en proyectos de programación, utilizando GitHub, Git y herramientas como Codex o Copilot.

---

## 🌳 Ramas principales

| Rama        | Descripción |
|-------------|-------------|
| `main`      | Rama principal con el código estable y aprobado |
| `develop`   | Rama para integrar cambios antes de pasar a `main` (opcional) |

---

## 🔄 Flujo de trabajo paso a paso

### 1. Crear una rama nueva
Cada vez que empieces una tarea:

```bash
git checkout -b feature-nombre-breve
```

> Ejemplos: `feature-form-contacto`, `fix-login-error`

---

### 2. Hacer cambios y commits

- Realizá los cambios en tu entorno local
- Escribí commits claros:

```bash
git add .
git commit -m "feat: agrega validación al formulario de contacto"
```

---

### 3. Subir la rama al repositorio remoto

```bash
git push origin feature-nombre-breve
```

---

### 4. Crear un Pull Request (PR)

- Ir a GitHub
- Crear un PR desde la rama que creaste hacia `main` o `develop`
- Agregar una descripción clara y detallada

---

### 5. Revisar y hacer merge

- Revisar que el código funcione correctamente
- Si todo está bien, hacer merge
- Elegí la opción **"Squash and merge"** si querés unificar los commits

---

### 6. Eliminar la rama

- GitHub ofrece un botón para eliminar la rama luego del merge
- También podés hacerlo desde tu máquina:

```bash
git branch -d feature-nombre-breve
git push origin --delete feature-nombre-breve
```

---

## 🧩 Convenciones de nombres para ramas

| Tipo      | Prefijo  | Ejemplo                    |
|-----------|----------|----------------------------|
| Funcionalidad nueva | `feature-` | `feature-header-video` |
| Corrección de error | `fix-`     | `fix-login-error`       |
| Documentación       | `docs-`    | `docs-readme`           |

---

## ✅ Buenas prácticas

- 🔒 No trabajar directo en `main`
- 💬 Escribir mensajes de commit descriptivos
- 🧠 Probar los cambios localmente antes de hacer merge
- 🧹 Borrar ramas una vez mergeadas

---

## 📂 Estructura sugerida del proyecto

```
/
├─ index.php
├─ contacto.php
├─ /assets
├─ /scripts
├─ /estilos
├─ /docs
│   └─ flujo-trabajo.md
├─ .gitignore
└─ README.md
```

---

## 💬 Frase para motivar al equipo
> "Cada commit es una huella de aprendizaje. Trabajá en equipo, escribí código claro y construí algo real."


