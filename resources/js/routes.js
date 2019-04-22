import MasterLayout from './layout/MasterLayout'
import DashboardPage from './pages/DashboardPage'
import DownloadPage from './pages/DownloadPage'
import UploadPage from './pages/UploadPage'

export default [
  {
    path: '/', redirect: '/downloads',
    component: MasterLayout,
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardPage
      },
      {
        path: '/downloads',
        name: 'downloads',
        component: DownloadPage
      },
      {
        path: '/uploads',
        name: 'uploads',
        component: UploadPage
      },
    ]
  }
]
