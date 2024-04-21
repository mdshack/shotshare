import pluginVue from 'eslint-plugin-vue'

export default [
    ...pluginVue.configs['flat/essential'],
    {
      rules: {
        "vue/multi-word-component-names": ["off"]
      }
    }
]
