pipeline {
  agent any
  environment {
    APP_ENV = 'testing'
  }
  stages {
    stage('checkout_repo') {
      steps {
        checkout scm
      }
    }
    stage('composer_install') {
      steps {
        sh "composer install"
      }
    }
    stage('setup_env') {
      steps {
        // Install dependencies, create a new .env file and generate a new key, just for testing
        sh "cp .env.ci .env"
      }
    }
    stage('npm_install') {
      steps {
        // Run any static asset building, if needed
        sh "npm install"
      }
    }
    stage('npm_run_dev') {
      steps {
        sh "npm run dev"
      }
    }
    stage('php_lint') {
      steps {
        sh 'find . -name "*.php" -not -path "./vendor/*" -not -path "./storage/*" -print0 | xargs -0 -n1 php -l'
      }
    }
    stage('js_lint') {
      steps {
        sh "npm run lint || true"
      }
    }
    // stage('dusk') {
    //   steps {
    //     sh "./tests/headlessDusk.sh"
    //   }
    // }
    stage('phpcs') {
      steps {
        withEnv(["PATH=/var/lib/jenkins/.composer/vendor/bin:$PATH"]) {
          sh "phpcs --report=summary --extensions=php --ignore='/bootstrap/*,/database/*,/public/*,/node_modules/*,/resources/*,/storage/*,*/tests/*,/vendor/*,envoy.blade.php,app/PageTemplates.php' ./ || true"
        }
      }
    }
    stage('phpmd') {
      steps {
        sh "phpmd app text phpmd.xml --ignore-violations-on-exit || true"
      }
    }
    stage('phpcpd') {
      steps {
        sh "phpcpd app || true"
      }
    }
    stage('phpunit') {
      steps {
        sh "./vendor/bin/phpunit"
      }
    }
    stage('deploy') {
      when {
        branch 'vff'
      }
      steps {
        // sh "curl https://forge.laravel.com/servers/108641/sites/266492/deploy/http?token=FdxdWIkXnMRXuwBXsPSe1LqcgQHgiL1EIuuyO48Q"
        echo "Deploy some day"
      }
    }
  }
  post {
    success {
      slackSend (color: "#8CC04F", message: "Completed ${env.JOB_NAME} (<${env.BUILD_URL}|build ${env.BUILD_NUMBER}>) successfully")
    }
    failure {
      slackSend (color: "#d54c53", message: "Failed ${env.JOB_NAME} (<${env.BUILD_URL}|build ${env.BUILD_NUMBER}>) - <${env.BUILD_URL}console|click here to see the console output>")
    }
  }
}
