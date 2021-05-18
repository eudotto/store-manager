FROM node:15.8-alpine

ARG USER_ID
ARG GROUP_ID

RUN deluser --remove-home node \
  && addgroup -S node -g ${GROUP_ID} \
  && adduser -S -G node -u ${USER_ID} node

RUN yarn global add @vue/cli@
