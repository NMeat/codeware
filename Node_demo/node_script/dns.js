const dns = require('dns');

// dns.lookup('iana.org', (err, address, family) => {
//   console.log('地址: %j 地址族: IPv%s', address, family);
// });


// dns.resolve4('archive.org', (err, addresses) => {
//   if (err) throw err;

//   console.log(`地址: ${JSON.stringify(addresses)}`);

//   addresses.forEach((a) => {
//     dns.reverse(a, (err, hostnames) => {
//       if (err) {
//         throw err;
//       }
//       console.log(`地址 ${a} 逆向解析到域名: ${JSON.stringify(hostnames)}`);
//     });
//   });
// });

// process.on('beforeExit', (code) => {
//   console.log('进程 beforeExit 事件的代码', code);
// })

// process.on('exit', (code) => {
//   console.log('进程 exit 事件的代码', code)
// })
// console.log('你好%s', 'hello world')
// console.log(require.main === module)
// console.log(require.main.filename)

// const EventEmitter = require('events');
// class MyEmitter extends EventEmitter {}

// const myEmitter = new MyEmitter();

// myEmitter.on('event', function (a, b) {
//   console.log('触发事件',a, b, this, this === myEmitter);
// });
// myEmitter.emit('event', 'a', 'b');

// const EventEmitter = require('events');
// const myEmitter = new EventEmitter();

// // 第一个监听器。
// myEmitter.on('a', function firstListener() {
//   console.log('第一个监听器');
// });
// // 第二个监听器。
// myEmitter.on('b', function secondListener(arg1, arg2) {
//   console.log(`第二个监听器中的事件有参数 ${arg1}、${arg2}`);
// });
// // 第三个监听器
// myEmitter.on('c', function thirdListener(...args) {
//   const parameters = args.join(', ');
//   console.log(`第三个监听器中的事件有参数 ${parameters}`);
// });

// console.log(myEmitter.listeners('event'));

// myEmitter.emit('a', 1, 2, 3, 4, 5);
// myEmitter.emit('b', 1, 2, 3, 4, 5);
// myEmitter.emit('c', 1, 2, 3, 4, 5);

// console.log(myEmitter.eventNames())
// console.log(myEmitter.listenerCount('b'))
// console.log(myEmitter.getMaxListeners())

try {
  const m = 2;
  const n = m + z;
} catch (err) {
  console.log(err)
}