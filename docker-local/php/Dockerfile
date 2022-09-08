FROM centos:7
WORKDIR /usr/share/nginx/html/
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN yum -y update

RUN yum install -y https://rpms.remirepo.net/enterprise/remi-release-7.rpm

ENV PHP_VERSION="82"

RUN yum -y install --enablerepo=remi,remi-php${PHP_VERSION} \
php \
php-devel \
php-pdo \
php-fpm \
php-mysqlnd \
php-mbstring \
php-xml \
php-pear

RUN pecl install xdebug-3.2.0alpha3
RUN useradd nginx
RUN yum -y install gcc make jq curl git

RUN yum -y install mysql

ENV NODEJS_VERSION="14.17.0"
RUN curl -sL https://rpm.nodesource.com/setup_14.x | bash -
RUN yum -y install --enablerepo=nodesource nodejs-${NODEJS_VERSION}

RUN yum clean all

RUN echo 'alias cd_doc_root="cd /usr/share/nginx/html/"' >> ~/.bashrc
RUN echo 'alias at="php artisan"' >> ~/.bashrc
RUN echo 'alias ll="ls -al"' >> ~/.bashrc

EXPOSE 9000

CMD ["/usr/sbin/php-fpm", "--nodaemonize"]
