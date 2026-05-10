# FastAdmin 财务系统

## 🧭 Project Type
A) FULLSTACK_WEB (frontend + backend)

## 🚀 How to Run (QA)
```bash
docker compose up
```

## Services
| Service | Port | Access URL |
|---------|------|------------|
| Frontend (Nginx) | 3000 | http://localhost:3000 |
| Backend (PHP-FPM) | 9000 (internal) | Via frontend |
| Database (MySQL) | 3306 | Internal only |

## Verification
1. Open http://localhost:3000
2. Login with default credentials:
   - Username: `admin`
   - Password: `admin`
3. Verify all menu items are accessible:
   - 控制台 (Console)
   - 餐厅收支管理 (Restaurant Income/Expense)
   - 住宿收支管理 (Accommodation Income/Expense)
   - 财务日常管理 (Daily Financial)
   - 员工薪资管理 (Employee Salary)

## Test Credentials
- Username: `admin`
- Password: `admin`

## Evidence
| File | Description |
|------|-------------|
| evidence/01_boot.txt | Docker services startup log (3 services healthy) |
| evidence/02_success.html | Login success page with redirect |
| evidence/03_failed.html | Login failed response |
| evidence/02_dashboard.html | Dashboard HTML after login |
| evidence/04_tree.txt | Project directory structure |
| evidence/05_key_code.txt | Database config + auth code |

## Tech Stack
- **Frontend**: HTML5, CSS3, Vanilla JavaScript (Nginx)
- **Backend**: PHP 7.4, ThinkPHP (FastAdmin)
- **Database**: MySQL 5.7

## Modules
1. **控制台** - Dashboard with statistics
2. **餐厅收支管理** - Restaurant income/expense management (CRUD)
3. **住宿收支管理** - Accommodation income/expense management (CRUD)
4. **财务日常管理** - Daily financial operations (CRUD)
5. **员工薪资管理** - Employee salary management with auto-calculation (CRUD)
