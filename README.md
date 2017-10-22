# ESIEA WEB PROJECT 2017
## AIL5MAJ - INF5041

### How to run in development mode
- `./run-dev.sh`
or
- `docker run --rm -v $(pwd):/src -w /src -p 8080:8080 node:6 bash -c "npm install && npm run dev"` in `webapp/src/` folder

### How to run in production mode
- `./run-prod.sh`
or
- `docker run --rm -v $(pwd):/src -w /src node:6 bash -c "npm install && npm run build"` in `webapp/src/` folder

### Run fake backend
- In `fake-backend`
- `npm install`
- `npm start`
