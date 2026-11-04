#!/usr/bin/env bash

set -euo pipefail

BASE_REF="${CS_FIX_BASE:-origin/main}"

REPO_ROOT="$(git rev-parse --show-toplevel)"
APP_DIR="$REPO_ROOT/src"

CONFIG_FILE=".php-cs-fixer.dist.php"

if ! git -C "$REPO_ROOT" rev-parse --verify "$BASE_REF" >/dev/null 2>&1; then
    echo "Erro: referência $BASE_REF não encontrada."
    echo "Execute: git fetch origin"
    exit 1
fi

MERGE_BASE="$(git -C "$REPO_ROOT" merge-base "$BASE_REF" HEAD)"

declare -A FILES=()

add_files() {
    while IFS= read -r -d '' file; do
        case "$file" in
            src/*.php)
                relative_path="${file#src/}"

                # Ignora o arquivo de configuração do PHP CS Fixer.
                if [[ "$relative_path" == "$CONFIG_FILE" ]]; then
                    continue
                fi

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

echo "Arquivos que serão formatados:"

for file in "${!FILES[@]}"; do
    echo " - $file"
done

echo ""

# Executa o PHP CS Fixer uma única vez.
docker compose exec -T app \
    vendor/bin/php-cs-fixer fix \
    --config="$CONFIG_FILE" \
    "${!FILES[@]}"

echo ""
echo "Formatação concluída!"