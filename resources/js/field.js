import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-vimeo', IndexField)
  app.component('detail-vimeo', DetailField)
  app.component('form-vimeo', FormField)
})
