FROM amazonlinux:2

RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN yum -y update
RUN amazon-linux-extras enable nginx1

ENV NGINX_VERSION="1.20.0"

RUN yum -y install --enablerepo=amzn2extra-nginx1 nginx-${NGINX_VERSION}

RUN yum clean all

EXPOSE 80 443
CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
