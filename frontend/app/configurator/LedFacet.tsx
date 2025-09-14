"use client";
import ArticleFacet from "./ArticleFacet";
import { useSelection } from "@/components/SelectionProvider";

export default function LedFacet() {
  const { selections } = useSelection();
  const growbox = selections.growbox;

  const category = process.env.NEXT_PUBLIC_LED_CATEGORY_ID || "";

  return (
    <ArticleFacet
      category={category}
      selectionKey="led"
      title="Grow-LED"
      queryKey={["ledArticles", growbox]}
      fetchArgs={[growbox]}
    />
  );
}
