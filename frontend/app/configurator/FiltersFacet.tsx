"use client";
import { fetchFilterOptions } from "@/lib/api";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";

export default function FiltersFacet() {
  const { setSelection } = useSelection();
  const { data } = fetchFilterOptions("default", 1);

  return (
    <FacetPanel title="Filters">
      <ul className="space-y-1">
        {data?.items?.map((opt) => (
          <li
            key={opt.value}
            className="cursor-pointer rounded p-2 hover:bg-gray-50"
            onClick={() => setSelection("filter", opt.value)}
          >
            {opt.label}
          </li>
        ))}
      </ul>
    </FacetPanel>
  );
}
