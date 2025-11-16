# TODO: Update Dashboard URLs for Kapitan and Kagawad

## Tasks
- [x] Update routes in routes/web.php: Change /admin/dashboard to /kapitan/dashboard and /admin/kagawad-dashboard to /kagawad/dashboard, update route names accordingly.
- [x] Update redirects in routes/web.php for /dashboard route.
- [x] Update ComplaintController.php: Change redirect routes for kapitan and kagawad.
- [x] Update AuthenticatedSessionController.php: Update redirect for admin/kapitan.
- [x] Update AdminController.php: Ensure view names are correct (no change needed if views stay).
- [x] Update views: Replace route('admin.dashboard') with route('kapitan.dashboard') in relevant views.
- [x] Update views: Replace route('admin.kagawad-dashboard') with route('kagawad.dashboard') in relevant views.
- [x] Test the changes by running the application and checking URLs.
