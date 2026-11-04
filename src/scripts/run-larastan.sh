
#!/usr/bin/env bash

set -euo pipefail

BASE_REF="${LARASTAN_BASE:-origin/main}"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/../.." && pwd)"
APP_DIR="$REPO_ROOT/src"

# Confirma que a referência-base existe.
if ! git -C "$REPO_ROOT" rev-parse --verify "$BASE_REF" >/dev/null 2>&1; then
    echo "Erro: referência $BASE_REF não encontrada."
    echo "Execute: git fetch origin"
    exit 1
fi

# Encontra o ancestral comum entre a branch atual e a base.
MERGE_BASE="$(git -C "$REPO_ROOT" merge-base "$BASE_REF" HEAD)"

declare -A FILES=()

add_files() {
    while IFS= read -r -d '' file; do
        case "$file" in
            src/*.php)
                relative_path="${file#src/}"

                if [[ -f "$APP_DIR/$relative_path" ]]; then
                    FILES["$relative_path"]=1
                fi
                ;;
        esac
    done
}

# Arquivos alterados na branch atual.
add_files < <(
    git -C "$REPO_ROOT" diff \
        --name-only -z \
        --diff-filter=ACMR \
        "$MERGE_BASE" HEAD
)

# Arquivos modificados localmente (staged e unstaged).
add_files < <(
    git -C "$REPO_ROOT" diff \
        --name-only -z \
        --diff-filter=ACMR \
        HEAD
)

# Arquivos novos ainda não rastreados.
add_files < <(
    git -C "$REPO_ROOT" ls-files \
        --others \
        --exclude-standard \
        -z
)

if [[ ${#FILES[@]} -eq 0 ]]; then
    echo "Nenhum arquivo PHP alterado encontrado."
    exit 0
fi

echo "Arquivos que serão analisados:"

for file in "${!FILES[@]}"; do
    echo " - $file"
done

echo ""

# Executa o Larastan uma única vez.
cd "$REPO_ROOT"

docker compose exec -T app \
    vendor/bin/phpstan analyse \
    --configuration=phpstan.neon \
    --no-progress \
    "${!FILES[@]}"
