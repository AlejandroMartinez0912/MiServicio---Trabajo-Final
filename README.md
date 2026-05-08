# MiServicio — Plataforma de gestión de servicios

Sistema web que conecta clientes con profesionales de distintos rubros, permitiendo gestionar turnos, cobros automáticos y calificaciones desde un único panel.

Desarrollado como Trabajo Final de la carrera Analista en Sistemas de Computación (UNaM).

---

## Funcionalidades principales

- **Agenda automática** — asignación de citas según disponibilidad horaria del profesional
- **Pagos automáticos** — integración con MercadoPago para cobro online al confirmar el turno
- **Sistema de calificaciones** — evaluación mutua entre cliente y profesional al finalizar el servicio
- **Gestión de servicios y rubros** — el profesional configura sus servicios, precios y horarios de trabajo
- **Facturación** — generación de comprobantes por cada transacción
- **Panel de informes** — métricas de citas, ingresos y calificaciones para el administrador
- **Auditoría** — registro de acciones dentro del sistema

---

## Tecnologías

| Capa | Tecnología |
|---|---|
| Backend | PHP 8 · Laravel |
| Frontend | Blade · JavaScript |
| Base de datos | MySQL |
| Pagos | MercadoPago API |

---

## Arquitectura

Aplicación MVC construida sobre Laravel. Los procesos automáticos (recordatorios, cobros) se manejan mediante **Laravel Queues** y **Scheduled Commands**. La integración con MercadoPago gestiona el flujo completo: preferencia de pago → webhook → confirmación → factura.

---

## Roles del sistema

| Rol | Acceso |
|---|---|
| Administrador | Panel completo, informes, gestión de rubros y usuarios |
| Profesional | Gestión de agenda, servicios y calificaciones recibidas |
| Cliente | Reserva de citas, historial de servicios y calificaciones |

---

## Capturas

> _Próximamente_

---

## Estado

✅ Completado — Trabajo Final aprobado
