# DynHost refresh scripts

Multiple scripts, written with different programming languages,
to automatically update a DynHost record.

Each script checks the current public IP address and, if it has changed,
updates the DynHost record.

## About OVH DynHost

DynHost allows to create a DNS record (domain or subdomain) that can be
dynamically updated to keep it in sync with its target IP address.
Dynamically updating a DNS record helps avoid interruptions of a web
service on IP change (when the server doesn't use a static IP address).

## Scripts

- [**Bash**](./bash) - A Bash script without dependencies to update
  a DynHost record
- [**PHP**](./php) - PHP scripts to update a DynHost record using Composer,
  Guzzle, PHP dotenv and PHP library for OVH API
- [**Python**](./python) - Python 3 scripts to request credentials and update
  a DynHost record using the Python library for OVH API

## License

**DynHost refresh scripts** are licensed under the GNU General Public License.
