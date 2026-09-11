# DVPS39 Attendify — Geofenced Workforce Monitoring System

A hackathon-ready local MVP inspired by the Attendify workflow: employee attendance, GPS geofencing, automatic punch-in, overtime-ready attendance records, manager live map, photo pins, alerts, employee management, leave approval, workplace configuration and CSV reporting.

## Requirements
- PHP 8.1+ with PDO SQLite and SQLite3
- A modern browser

## Run on Windows
Open PowerShell in this folder:

```powershell
php setup.php
php -S localhost:8000 -t public
```
Then open `http://localhost:8000`.

## Demo accounts
- Manager: `manager@dvps39.test` / `password`
- Employee: `employee@dvps39.test` / `password`
- Aisha: `aisha@dvps39.test` / `password`
- Vikram: `vikram@dvps39.test` / `password`

## Demo flow
1. Sign in as employee.
2. Click **Enable automatic GPS** and allow location, or use **Simulate Inside**.
3. The server calculates distance to the configured workplace and automatically creates today's punch-in while inside the geofence during the shift.
4. Use **Simulate Outside** to generate an outside-geofence manager alert.
5. Capture an identity photo; the manager live map uses the stored photo as the pin.
6. Submit remote/medical leave and approve it as manager.
7. Manager can configure workplace coordinates/radius/shift and export CSV reports.

## Notes
The browser Geolocation API requires user permission. Demo simulation controls are intentionally included for a reliable hackathon presentation on a single laptop.
